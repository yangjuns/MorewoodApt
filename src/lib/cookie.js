export function setCookie(key, value) {
    document.cookie = `${key}=${value}`;
}

export function getCookie(key) {
    const cookie = document.cookie;
    const valIndex = cookie.indexOf(`${key}=`) + key.length + 1;
    const valEnd = cookie.indexOf(";", valIndex);
    if (valEnd < 0) {
        return cookie.substr(valIndex);
    }
    return cookie.substring(valIndex, valEnd);
}
