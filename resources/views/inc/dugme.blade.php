<button id="scrollToTop" class="hidden fixed bottom-5 right-5   bg-gradient-to-r from-blue-500 to-lightblue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition hover:cursor-pointer">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
    </svg>
</button>

<script>
document.addEventListener("scroll", function() {
    const button = document.getElementById("scrollToTop");
    if (window.scrollY > 300) {
        button.classList.remove("hidden");
    } else {
        button.classList.add("hidden");
    }
});

document.getElementById("scrollToTop").addEventListener("click", function() {
    window.scrollTo({ top: 0, behavior: "smooth" });
});
</script>
