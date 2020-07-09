class Cookies {
  static set(cname, cvalue, exdays) {
    let d = new Date()
    let value = JSON.stringify(cvalue)

    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000)
    let expires = 'expires=' + d.toUTCString()
    document.cookie = cname + '=' + value + ';' + expires + ';path=/'
  }

  static get(cname) {
    let name = cname + '='
    let decodedCookie = decodeURIComponent(document.cookie)
    let split = decodedCookie.split(';')
    let filtered = split.filter(value => !value.trim().indexOf(name))
    return filtered[0]
      ? JSON.parse(filtered[0].trim().substring(name.length))
      : []
  }

  static delete(cname) {
    document.cookie =
      cname + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;'
  }
}

export default Cookies
