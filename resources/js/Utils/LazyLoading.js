let fetchUrl = null

document.addEventListener('DOMContentLoaded', function() {
  var bottom = document.getElementById('bottom')

  if (!bottom) return

  var imageObserver = new IntersectionObserver(function(entries, observer) {
    let currentBottomOffset = bottom.offsetTop < 100 ? 0 : bottom.offsetTop

    entries.forEach(function(entry) {
      if (entry.isIntersecting && fetchUrl !== null) {
        fetch(fetchUrl, {
          headers: {
            Accept: 'application/json',
          },
        })
          .then(response => response.json())
          .then(result => {
            result.images.data.forEach(image => {
              let div = document.createElement('div')
              div.classList.add('h-full')

              if (image.id % 4 === 0) {
                div.classList.add('gallery-item-wide')
              } else if (image.id % 4 === 1) {
                div.classList.add('gallery-item-tall')
              } else if (image.id % 4 === 2) {
                div.classList.add('gallery-item-wide', 'gallery-item-tall')
              }

              let img = document.createElement('img')
              img.setAttribute('src', '/storage/' + image.filename)
              img.classList.add('grid-image')
              img.addEventListener('click', function(event) {
                document.getElementById('gallery-modal').style.display = 'block'
                document.getElementById('modal-image').src = event.target.src
              })
              div.appendChild(img)

              document.getElementById('image-container').appendChild(div)
            })

            window.scrollTo(0, currentBottomOffset)

            fetchUrl = result.images.links[result.images.links.length - 1].url
          })
      }
    })
  })

  imageObserver.observe(bottom)
})

export function setUrl(url) {
  fetchUrl = url
}

export function closeImage() {
  document.getElementById('gallery-modal').style.display = 'none'
}
