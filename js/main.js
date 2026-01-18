// 탭 활성화 처리
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-link');
    const hash = window.location.hash;
    let activeTabFound = false;

    tabs.forEach(tab => {
        if (hash) {
            if (tab.getAttribute('href').includes(hash)) {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                activeTabFound = true;
            }
        }
    });

    if (!activeTabFound) {
        const defaultActiveTab = document.querySelector('.tab-link.active');
        if (defaultActiveTab) {
            defaultActiveTab.classList.add('active');
        }
    }
});

// 오프셋을 적용한 스크롤 함수
function scrollToElementWithOffset(elementId) {
    const targetElement = document.getElementById(elementId);
    if (targetElement) {
        const offset = window.innerHeight * 0.15;
        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
        const scrollPosition = targetPosition - offset;

        window.scrollTo({
            top: scrollPosition,
            behavior: 'smooth'
        });
    }
}

// 페이지 로드 시 해시가 있으면 스크롤
document.addEventListener('DOMContentLoaded', function () {
    const hash = window.location.hash;
    
    if (hash) {
        const targetId = hash.substring(1);
        setTimeout(() => {
            scrollToElementWithOffset(targetId);
        }, 300);
    }
});
