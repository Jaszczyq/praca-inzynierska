<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // Przesuwanie do poprzedniego dnia
    $('.flex-prev').click(function(e) {
        e.preventDefault();
        var activeSlide = $('.slides .slide.active');
        var prevSlide = activeSlide.prev('.slide');
        if (prevSlide.length > 0) {
            activeSlide.removeClass('active');
            prevSlide.addClass('active');
            // Tutaj możesz wykonać żądanie AJAX lub przekierować użytkownika do odpowiedniej strony
            console.log('Przesunięto do poprzedniego dnia');
        }
    });

    // Przesuwanie do następnego dnia
    $('.flex-next').click(function(e) {
    e.preventDefault();
    var activeSlide = $('.slides .slide.active');
    var nextSlide = activeSlide.next('.slide');
    if (nextSlide.length > 0) {
    activeSlide.removeClass('active');
    nextSlide.addClass('active');
    // Tutaj możesz wykonać żądanie AJAX lub przekierować użytkownika do odpowiedniej strony
    console.log('Przesunięto do następnego dnia');
}
});
});

</script>
