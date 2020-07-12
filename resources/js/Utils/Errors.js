class Errors {
  constructor(errors = {}) {
    this.record(errors)
  }

  record(errors = {}) {
    this.errors = errors

    Object.keys(errors).forEach(key => {
      this[key] = errors[key][0]
    })
  }

  all() {
    return this.errors
  }

  count() {
    return Object.keys(this.errors).length
  }

  any() {
    return this.count() > 0
  }

  has(...keys) {
    return keys.some(key => {
      if (key.slice(-1) === '*') {
        return Object.keys(this.errors).some(key => key.startsWith(key.slice(0, -1)))
      } else {
        return Object.keys(this.errors).includes(key)
      }
    })
  }

  first(...fields) {
    const error = fields.find(field => this.has(field))

    if (error && error.slice(-1) === '*') {
      let error = Object.keys(this.errors).find(key => key.startsWith(key.slice(0, -1)))

      return error ? this.errors[error][0] : null
    } else {
      return error ? this.errors[error][0] : null
    }
  }

  get(field) {
    return this.errors[field] || []
  }
}

export default Errors
