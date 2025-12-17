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
                }else{
                    if(response.shortenedUrl){
                        $(".generated-url").html(`<p class="text-center" style="font-size:18px;"> Short URL : 
                            <a href=${response.originalUrl} target="_blank">${response.shortenedUrl}</a>
                            </p>`)
                    }
                }
            },
            error: (response) => {
                console.error(response)
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

    $(".url-shortner").on("click", () => {
        window.location.href = '/dashboard/urlShortner'
    })

    $(".urls").on("click",() => {
        window.location.href = '/dashboard/shortenedUrls'
    })

    $(".url-list").on("click",() => {
        window.location.href = '/urls'
    })

    $(".role-manager").on("change",function () {
        const roleSelected = $(this).val()
        const user = $(this).closest('tr').data('id')
        if(user !== ''){
            getToken()
            formHandler('PATCH','/dashboard/updateRole/'+user,{'role_selected':roleSelected})
        }else{
            console.error('Please select a valid role')
        }
    })

    $(".company-manager").on("change", function() {
        const companySelected = $(this).val()
        const user = $(this).closest('tr').data('id')
        if(user !== ''){
            getToken()
            formHandler('POST','/dashboard/invite/'+user,{'company_selected':companySelected})
        }else{
            console.error('Please select a valid role')
        }
    })

    $(".generate-url").on("click", (e) => {
        e.preventDefault()
        const longUrl = $('input#urlshortner').val()
        const companyId = $('select#url-for-compnay').val()
        console.log(companyId)
        getToken();
        formHandler('POST','/dashboard/urlShortner/',{'long_url':longUrl, 'company_id': companyId})
    })
});