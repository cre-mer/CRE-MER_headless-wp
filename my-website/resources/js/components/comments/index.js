import ReactDOM from 'react-dom';
import React from 'react';

// Import internal dependencies
import FboReactComponent from '../fbo-react-component';
import CommentForm from '../comment-form';
import methods from './methods';
import props from './props';

class Comments extends FboReactComponent {

    constructor(props) {
        super(props);

        this.state = {}
    }

    render() {
        const { postId } = this.props;
        const {} = this.state;

        return (
            <CommentForm postId={postId} />
        )
    }

}

// Render component
window.addEventListener("load", () => {
    // Fully loaded!
	const comments = document.getElementById('comments');
    // Comments form
	ReactDOM.render(<Comments {...comments.dataset} />, comments);
});
