let count =1;
document.getElementById("radio1").checked = true;

setInterval(function (){
    nextImage();
}, 3000)

function nextImage() {
    count++;
    if (count > 3) {
        count = 1;
    }

    document.getElementById("radio" + count).checked = true;
}


document.addEventListener("DOMContentLoaded", function() {
    const historiaItems = document.querySelectorAll(".historia-item");
    let currentIndex = 0;

    function showSlide(index) {
        historiaItems.forEach((item, i) => {
            if (i === index) {
                item.style.display = "inline-block";
            } else {
                item.style.display = "none";
            }
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % historiaItems.length;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + historiaItems.length) % historiaItems.length;
        showSlide(currentIndex);
    }

    // Exibir o primeiro slide
    showSlide(currentIndex);

    // Adicionar eventos de clique para avançar e retroceder
    document.getElementById("next-btn").addEventListener("click", nextSlide);
    document.getElementById("prev-btn").addEventListener("click", prevSlide);
});
