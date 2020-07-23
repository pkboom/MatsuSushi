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

  has(...fields) {
    return fields.some(field => {
      if (field.slice(-1) === '*') {
        return Object.keys(this.errors).some(key =>
          key.startsWith(field.slice(0, -1))
        )
      } else {
        return Object.keys(this.errors).includes(field)
      }
    })
  }

  first(...fields) {
    let error = fields.find(field => this.has(field))

    if (error && error.slice(-1) === '*') {
      error = Object.keys(this.errors).find(key =>
        key.startsWith(error.slice(0, -1))
      )
    }

    return error ? this.errors[error][0] : null
  }

  get(field) {
    return this.errors[field] || []
  }
}

export default Errors
