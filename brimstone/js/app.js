document.addEventListener("DOMContentLoaded", () => {
    const textElement = document.getElementById("typewriterText");

    if (textElement) {
        const fullText = textElement.getAttribute("data-text");
        textElement.innerHTML = ""; 
        
        let i = 0;
        const speed = 30; 

        function typeWriter() {
            if (i < fullText.length) {
                textElement.innerHTML += fullText.charAt(i);
                i++;
                setTimeout(typeWriter, speed);
            }
        }

        typeWriter();
    }
});