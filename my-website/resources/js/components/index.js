/**
* Import components
*/
import './example-component';


// Render component
window.addEventListener("load", () => {
    // Fully loaded!
    const example = document.getElementById('example-id');
	example ?? ReactDOM.render(<ExampleComponent {...map.dataset} />, map);
});
