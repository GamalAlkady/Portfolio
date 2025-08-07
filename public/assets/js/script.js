// Form validation and handling

$(document).ready(function () {

    $('#menu').click(function () {
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('scroll load', function () {
        $('#menu').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        if (window.scrollY > 60) {
            document.querySelector('#scroll-top').classList.add('active');
        } else {
            document.querySelector('#scroll-top').classList.remove('active');
        }

        // scroll spy
        $('section').each(function () {
            let height = $(this).height();
            let offset = $(this).offset().top - 200;
            let top = $(window).scrollTop();
            let id = $(this).attr('id');

            if (top > offset && top < offset + height) {
                $('.navbar ul li a').removeClass('active');
                $('.navbar').find(`[href="#${id}"]`).addClass('active');
            }
        });
    });

    // smooth scrolling
    $('a[href*="#"]').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top,
        }, 500, 'linear')
    });

    // <!-- emailjs to mail contact form data -->
    // $("#contact-form").submit(function (event) {
    //     emailjs.init("user_TTDmetQLYgWCLzHTDgqxm");
    //
    //     emailjs.sendForm('contact_service', 'template_contact', '#contact-form')
    //         .then(function (response) {
    //             console.log('SUCCESS!', response.status, response.text);
    //             document.getElementById("contact-form").reset();
    //             alert("Form Submitted Successfully");
    //         }, function (error) {
    //             console.log('FAILED...', error);
    //             alert("Form Submission Failed! Try Again");
    //         });
    //     event.preventDefault();
    // });
    // <!-- emailjs to mail contact form data -->

});

document.addEventListener('visibilitychange',
    function () {
        if (document.visibilityState === "visible") {
            document.title = "Portfolio | Mohammed Al-Qadi";
            $("#favicon").attr("href", "assets/images/favicon.png");
        }
        else {
            document.title = "Come Back To Portfolio";
            $("#favicon").attr("href", "assets/images/favhand.png");
        }
    });


// <!-- typed js effect starts -->
var typed = new Typed(".typing-text", {
    strings: ["frontend development", "backend development", "web designing", "android development", "web development"],
    loop: true,
    typeSpeed: 50,
    backSpeed: 25,
    backDelay: 500,
});
// <!-- typed js effect ends -->

async function fetchData(type = "skills") {
    let response
    type === "skills" ?
        response = await fetch("skills.json")
        :
        response = await fetch("./projects/projects.json")
    const data = await response.json();
    return data;
}

function showSkills(skills) {
    let skillsContainer = document.getElementById("skillsContainer");
    let skillHTML = "";
    skills.forEach(skill => {
        skillHTML += `
        <div class="bar">
              <div class="info">
                <img src=${skill.icon} alt="skill" />
                <span>${skill.name}</span>
              </div>
            </div>`
    });
    skillsContainer.innerHTML = skillHTML;
}

function showProjects(projects) {
    let projectsContainer = document.querySelector("#work .box-container");
    let projectHTML = "";
    projects.slice(0, 10).filter(project => project.category != "android").forEach(project => {
        projectHTML += `
        <div class="box tilt">
      <img draggable="false" src="/assets/images/projects/${project.image}.png" alt="project" />
      <div class="content">
        <div class="tag">
        <h3>${project.name}</h3>
        </div>
        <div class="desc">
          <p>${project.desc}</p>
          <div class="btns">
            <a href="${project.links.view}" class="btn" target="_blank"><i class="fas fa-eye"></i> View</a>
            <a href="${project.links.code}" class="btn" target="_blank">Code <i class="fas fa-code"></i></a>
          </div>
        </div>
      </div>
    </div>`
    });
    projectsContainer.innerHTML = projectHTML;

    // <!-- tilt js effect starts -->
    VanillaTilt.init(document.querySelectorAll(".tilt"), {
        max: 15,
    });
    // <!-- tilt js effect ends -->

    /* ===== SCROLL REVEAL ANIMATION ===== */
    const srtop = ScrollReveal({
        origin: 'top',
        distance: '80px',
        duration: 1000,
        reset: true
    });

    /* SCROLL PROJECTS */
    srtop.reveal('.work .box', { interval: 200 });

}

fetchData().then(data => {
    showSkills(data);
});

fetchData("projects").then(data => {
    showProjects(data);
});

// <!-- tilt js effect starts -->
VanillaTilt.init(document.querySelectorAll(".tilt"), {
    max: 15,
});
// <!-- tilt js effect ends -->


// pre loader start
// function loader() {
//     document.querySelector('.loader-container').classList.add('fade-out');
// }
// function fadeOut() {
//     setInterval(loader, 500);
// }
// window.onload = fadeOut;
// pre loader end

// disable developer mode
document.onkeydown = function (e) {
    if (e.keyCode == 123) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        return false;
    }
}

// Start of Tawk.to Live Chat
var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
(function () {
    var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/60df10bf7f4b000ac03ab6a8/1f9jlirg6';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();
// End of Tawk.to Live Chat


/* ===== SCROLL REVEAL ANIMATION ===== */
const srtop = ScrollReveal({
    origin: 'top',
    distance: '80px',
    duration: 1000,
    reset: true
});

/* SCROLL HOME */
srtop.reveal('.home .content h3', { delay: 200 });
srtop.reveal('.home .content p', { delay: 200 });
srtop.reveal('.home .content .btn', { delay: 200 });

srtop.reveal('.home .image', { delay: 400 });
srtop.reveal('.home .linkedin', { interval: 600 });
srtop.reveal('.home .github', { interval: 800 });
srtop.reveal('.home .twitter', { interval: 1000 });
srtop.reveal('.home .telegram', { interval: 600 });
srtop.reveal('.home .instagram', { interval: 600 });
srtop.reveal('.home .dev', { interval: 600 });

/* SCROLL ABOUT */
srtop.reveal('.about .content h3', { delay: 200 });
srtop.reveal('.about .content .tag', { delay: 200 });
srtop.reveal('.about .content p', { delay: 200 });
srtop.reveal('.about .content .box-container', { delay: 200 });
srtop.reveal('.about .content .resumebtn', { delay: 200 });


/* SCROLL SKILLS */
srtop.reveal('.skills .container', { interval: 200 });
srtop.reveal('.skills .container .bar', { delay: 400 });

/* SCROLL EDUCATION */
srtop.reveal('.education .box', { interval: 200 });

/* SCROLL PROJECTS */
srtop.reveal('.work .box', { interval: 200 });

/* SCROLL EXPERIENCE */
srtop.reveal('.experience .timeline', { delay: 400 });
srtop.reveal('.experience .timeline .container', { interval: 400 });

/* SCROLL CONTACT */
srtop.reveal('.contact .container', { delay: 400 });
srtop.reveal('.contact .container .form-group', { delay: 400 });

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('productForm');

    // const imagesInput = document.getElementById('images');
    // const imagesDropzone = document.getElementById('imagesDropzone');
    //
    // // Set up dropzone event listeners
    // if (imagesDropzone) {
    //     setupDropzone(imagesDropzone, imagesInput);
    //     imagesInput.addEventListener('change', function () {
    //         previewImage(this, 'imagesPreview', false);
    //     });
    // }

    // Form submission
    form.addEventListener('submit', function (e) {
        console.log('sss')
            e.preventDefault();
        if (!validateForm()) {
        }
    });
});


// Set up drag and drop functionality
function setupDropzone(dropzone, input) {
    dropzone.addEventListener('click', () => input.click());

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropzone.classList.add('border-primary', 'bg-blue-50');
    }

    function unhighlight() {
        dropzone.classList.remove('border-primary', 'bg-blue-50');
    }

    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        input.files = files;

        previewImage(input, 'imagesPreview', false);

    }
}

// Preview selected image
function previewImage(input, previewId, isMain) {
    const preview = document.getElementById(previewId);

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            if (isMain) {
                preview.innerHTML = `<img src="${e.target.result}" class="mx-auto max-h-40 rounded-lg" alt="Preview">`;
            } else {
                preview.innerHTML = `<img src="${e.target.result}" class="mx-auto max-h-40 rounded-lg" alt="Preview">`;
                preview.innerHTML += `<p class="text-gray-600 mt-2">${input.files.length} image(s) selected</p>`;
            }
        }

        reader.readAsDataURL(input.files[0]);
    } else if (input.files && input.files.length > 1) {
        preview.innerHTML = `<p class="text-gray-600">${input.files.length} images selected</p>`;
    } else {
        if (isMain) {
            preview.innerHTML = `
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Click to upload main image</p>
                        <p class="text-gray-500 text-sm mt-1">PNG, JPG, GIF up to 5MB</p>
                    `;
        } else {
            preview.innerHTML = `
                        <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Click to upload additional images</p>
                        <p class="text-gray-500 text-sm mt-1">Select multiple images (up to 5)</p>
                    `;
        }
    }
}

// Validate form
function validateForm() {
    let isValid = true;

    // Reset errors
    document.querySelectorAll('.form-error').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });

    // Validate title
    const title = document.getElementById('title').value.trim();
    if (!title) {
        showError('titleError', 'Product title is required');
        isValid = false;
    } else if (title.length < 3) {
        showError('titleError', 'Title must be at least 3 characters');
        isValid = false;
    }

    // Validate description
    const description = document.getElementById('description').value.trim();
    if (!description) {
        showError('descriptionError', 'Description is required');
        isValid = false;
    } else if (description.length < 10) {
        showError('descriptionError', 'Description must be at least 10 characters');
        isValid = false;
    }

    // Validate category
    const category = document.getElementById('category').value;
    if (!category) {
        showError('categoryError', 'Please select a category');
        isValid = false;
    }

    // Validate technologies
    const technologies = document.getElementById('technologies').value.trim();
    if (!technologies) {
        showError('technologiesError', 'Technologies are required');
        isValid = false;
    } else if (technologies.split(',').length < 1) {
        showError('technologiesError', 'Please enter at least one technology');
        isValid = false;
    }

    // Validate URLs
    const hostUrl = document.getElementById('hostUrl').value.trim();
    const githubUrl = document.getElementById('githubUrl').value.trim();

    if (hostUrl && !isValidUrl(hostUrl)) {
        showError('hostUrlError', 'Please enter a valid URL');
        isValid = false;
    }

    if (githubUrl && !isValidUrl(githubUrl)) {
        showError('githubUrlError', 'Please enter a valid GitHub URL');
        isValid = false;
    }

    // Validate additional images
    const images = document.getElementById('images').files;
    // console.log(images)
    if (images.length === 0) {
        showError('imagesError', 'You must insert at least one image.');
        isValid = false;
    } else if (images.length > 5) {
        showError('imagesError', 'You can upload maximum 5 additional images');
        isValid = false;
    }

    for (let i = 0; i < images.length; i++) {
        if (images[i].size > 5 * 1024 * 1024) {
            showError('imagesError', 'Each image size must be less than 5MB');
            isValid = false;
            break;
        }
    }

    return isValid;
}

// Show error message
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
    errorElement.classList.remove('hidden');
}

// Validate URL format
function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

// Reset form
function resetForm() {
    document.getElementById('productForm').reset();

    // Reset previews
    document.getElementById('mainImagePreview').innerHTML = `
                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                <p class="text-gray-600">Click to upload main image</p>
                <p class="text-gray-500 text-sm mt-1">PNG, JPG, GIF up to 5MB</p>
            `;

    document.getElementById('imagesPreview').innerHTML = `
                <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                <p class="text-gray-600">Click to upload additional images</p>
                <p class="text-gray-500 text-sm mt-1">Select multiple images (up to 5)</p>
            `;

    // Reset errors
    document.querySelectorAll('.form-error').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}