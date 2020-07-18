export function isUrl(...urls) {
  return urls.flat().filter(url => {
    if (url.slice(-1) === '*') {
      return location.pathname.substr(1).startsWith(url.slice(0, -1))
    } else {
      return location.pathname.substr(1) === url.replace(/\/$/, '')
    }
  }).length
}

export function isNotUrl(...urls) {
  return !isUrl(...urls)
}
