export default {
    mounted(el, binding) {
        let options = {
            rootMargin: "0px",
            threshold: 1.0,
        };

        const callback = (entries, observer) => {
            if (entries[0].isIntersecting) {
                binding.value.current_page += 1
                binding.value.method(binding.value.news_id, binding.value.current_page)
            }
        }
        let observer = new IntersectionObserver(callback, options);
        observer.observe(el)
    }
}
