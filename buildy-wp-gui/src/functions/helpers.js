const debounce = (fn, delay) => {
  var timeoutID = null
  return function () {
    clearTimeout(timeoutID)
    var args = arguments
    var that = this
    timeoutID = setTimeout(function () {
      fn.apply(that, args)
    }, delay)
  }
}

const UCFirst = (text) => {
  return text.charAt(0).toUpperCase() + text.slice(1)
}

const labelUCFirst = (type) => {
  let label = type.replace('-module', '')
  return label.charAt(0).toUpperCase() + label.slice(1)
}

const spaceToDash = (str) => {
  str = str.replace(/\s+/g, '-').toLowerCase();
  return str
}

export { debounce, labelUCFirst, UCFirst, spaceToDash }