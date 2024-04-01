// check if cookie bearerToken is set
if(!document.cookie.includes('token')) {
    window.location.href = '/login.html';
} else {
}