$(document).ready(function () {
    let token = null;
    const getToken = () => {
        token = $('meta[name="csrf-token"]').attr('content')
    }

    const formHandler = (method, url) => {
        $.ajax({
            type: method,
            url: url,
            headers: {
                'X-CSRF-TOKEN': token
             },
            success: (response) => {
                console.log('success',response)
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
});