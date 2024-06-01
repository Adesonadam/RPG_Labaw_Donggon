let menuIcon = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');
let sections = document.querySelectorAll('section');
let navLinks = document.querySelectorAll('header nav a');


window.onscroll = () => {
    sections.forEach(sec =>{
        let top = window.scrollY;
        let offset = sec.offsetTop - 150;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if(top >= offset && top < offset + height){
            navLinks.forEach(links => {
                links.classList.remove('active');
                document.querySelector('header nav a [href*=' + id + ' ]').classList.add('active')
            })
        }
    })
}
menuIcon.onclick = () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
}



// Carousel
let currentIndex = 0;
const items = document.querySelectorAll('.carousel-item');

function showSlide(index) {
  items.forEach(item => {
    item.style.transform = `translateX(-${index * 100}%)`;
  });
}

document.querySelector('.prev').addEventListener('click', () => {
  currentIndex = (currentIndex === 0) ? items.length - 1 : currentIndex - 1;
  showSlide(currentIndex);
});

document.querySelector('.next').addEventListener('click', () => {
  currentIndex = (currentIndex === items.length - 1) ? 0 : currentIndex + 1;
  showSlide(currentIndex);
});


//NAVBAR
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    const scrollTop = window.pageYOffset;

    if (scrollTop > 50) {
        header.style.backgroundColor = 'black'; // Change to solid background color
    } else {
        header.style.backgroundColor = 'transparent'; // Change back to transparent
    }
});

