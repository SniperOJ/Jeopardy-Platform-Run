(function(){
function animate(item, x, y, index) {
dynamics.animate(item, {
translateX: x,
translateY: y,
opacity: 1
}, {
type: dynamics.spring,
duration: 800,
frequency: 120,
delay: 100 + index * 30
});
}
minigrid('.grid', '.grid-item', 6, animate);
window.addEventListener('resize', function(){
minigrid('.grid', '.grid-item', 6, animate);
});
})();