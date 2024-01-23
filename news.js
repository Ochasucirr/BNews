document.addEventListener('DOMContentLoaded', function() {
    const transitionItems = document.querySelectorAll('.transition-item');
  
    function checkTransitionItems() {
      transitionItems.forEach(item => {
        if (isElementInViewport(item) && !item.classList.contains('active')) {
          item.classList.add('active');
        }
      });
    }
  
    function isElementInViewport(el) {
      const rect = el.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }
  
    // Panggil fungsi saat halaman dimuat dan saat di-scroll
    checkTransitionItems();
    window.addEventListener('scroll', checkTransitionItems);
  });
  