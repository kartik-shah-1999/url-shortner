$(document).ready(function () {
    let token = null;
    const getToken = () => {
        token = $('meta[name="csrf-token"]').attr('content')
    }

    const formHandler = (method, url, data=null) => {
        $.ajax({
            type: method,
            url: url,
            headers: {
                'X-CSRF-TOKEN': token
             },
            data: data,
            success: (response) => {
                if(response.redirectUrl){
                    window.location.href = response.redirectUrl
                }
            },
            error: (response) => {
                console.log('error',response)
            }
        })
    }

    $(".logout").on("click",() => {
        getToken()
        formHandler('POST','/logout')
    })

    $(".dashboard").on("click" ,() => {
        window.location.href = '/dashboard'
    })

    $(".company").on("click",() => {
        window.location.href = '/dashboard/company'
    })

    $(".invite").on("click", () => {
        window.location.href = '/dashboard/invite'
    })

    $(".urls").on("click", () => {
        window.location.href = '/dashboard/users'
    })

    $(".role").on("click", () => {
        window.location.href = '/dashboard/role'
    })

    $(".role-manager").on("change",function () {
        const roleSelected = $(this).val()
        const user = $(this).closest('tr').data('id')
        getToken()
        formHandler('PATCH','/dashboard/updateRole/'+user,{'role_selected':roleSelected})
    })
});