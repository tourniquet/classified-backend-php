/* global XMLHttpRequest, alert */

function removeImage (image, item) { // eslint-disable-line no-unused-vars
  let xhr = new XMLHttpRequest()
  xhr.open('GET', `../admin/remove-image.php?image=${image}&item=${item}`)
  xhr.send()

  xhr.onload = function () {
    if (xhr.status === 200) {
      alert(`image: ${image}, item: ${item}`)
      document.getElementById(image).remove()
    }
  }

  xhr.onerror = function () {
    alert('Request failed')
  }
}
