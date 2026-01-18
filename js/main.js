// 탭 활성화 및 스크롤 처리
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-link');
    const hash = window.location.hash;
    let activeTabFound = false;

    // 1. URL 해시가 있다면 그 탭을 활성화
    if (hash) {
        // 해시에서 # 제거
        const targetId = hash.substring(1);
        
        tabs.forEach(tab => {
            // 탭의 href에 해당 해시가 포함되어 있는지 확인
            if (tab.getAttribute('href') && tab.getAttribute('href').includes(targetId)) {
                // 모든 탭 비활성화
                tabs.forEach(t => t.classList.remove('active'));
                // 해당 탭 활성화
                tab.classList.add('active');
                activeTabFound = true;
                
                // 부드러운 스크롤 이동
                setTimeout(() => {
                    scrollToElementWithOffset(targetId);
                }, 300);
            }
        });
    }

    // 2. 해시로 활성화된 탭이 없다면, HTML(PHP)에서 지정한 active 클래스 유지
    // (functions.php에서 설정한 '기본 활성화' 값이 이미 렌더링되어 있음)
    if (!activeTabFound) {
        // 이미 active 클래스가 있는 요소가 있는지 확인
        const defaultActive = document.querySelector('.tab-link.active');
        if (!defaultActive && tabs.length > 0) {
            // 만약 아무것도 active가 없다면 첫번째를 강제 활성화 (안전장치)
            tabs[0].classList.add('active');
        }
    }
});

// 오프셋을 적용한 스크롤 함수
function scrollToElementWithOffset(elementId) {
    const targetElement = document.getElementById(elementId);
    if (targetElement) {
        // 헤더와 탭 높이를 고려한 오프셋 (약 100px)
        const offset = 100; 
        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
        const scrollPosition = targetPosition - offset;

        window.scrollTo({
            top: scrollPosition,
            behavior: 'smooth'
        });
    }
}
