import Cookies from './Cookies'

class OrderInCart {
  constructor(cookieName) {
    this.orders = Cookies.get(cookieName)
    this.cookieName = cookieName
  }

  static getCookie(cookieName) {
    return new this(cookieName)
  }

  get() {
    return this.orders
  }

  place(order) {
    this.orders.push(order)
    this.storeForAWeekInCookie()
  }

  storeForAWeekInCookie() {
    Cookies.set(this.cookieName, this.orders, 7)
  }

  remove(index) {
    this.orders.splice(index, 1)
    this.storeForAWeekInCookie()
    return this.orders
  }

  update(index, value) {
    this.orders[index].quantity = value
    this.storeForAWeekInCookie()
    return this.orders
  }

  subTotal() {
    return this.orders
      .map(el => parseFloat(el.price) * parseFloat(el.quantity))
      .reduce((acc, cur) => acc + cur, 0)
      .toFixed(2)
  }

  count() {
    return this.orders.length || null
  }
}

export default OrderInCart
