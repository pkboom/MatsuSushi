export function isUrl(prefix, ...urls) {
  prefix = prefix && prefix.replace(/^\//, '')

  return urls
    .flat()
    .map(url => (prefix ? `${prefix}/${url}` : url))
    .filter(url => {
      if (url.slice(-1) === '*') {
        return location.pathname.substr(1).startsWith(url.slice(0, -1))
      } else {
        return location.pathname.substr(1) === url.replace(/\/$/, '')
      }
    }).length
}

export function isNotUrl(prefix, ...urls) {
  return !this.isUrl(prefix, ...urls)
}
