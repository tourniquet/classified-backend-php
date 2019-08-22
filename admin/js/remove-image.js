/* global XMLHttpRequest, alert, confirm */

function removeImage (image, item) { // eslint-disable-line no-unused-vars
  let xhr = new XMLHttpRequest()
  xhr.open('GET', `../admin/remove-image.php?image=${image}&item=${item}`)
  if (confirm('Are you sure you want to delete this image?')) {
    xhr.send()
  }

  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById(image).remove()
    }
  }

  xhr.onerror = function () {
    alert('Request failed')
  }
}
