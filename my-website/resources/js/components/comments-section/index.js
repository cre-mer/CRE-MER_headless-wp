import ReactDOM from 'react-dom';
import React from 'react';

// Import internal dependencies
import FboReactComponent from '../fbo-react-component';
import CommentForm from '../comment-form';
import Comments from '../comments';

class CommentsSection extends FboReactComponent {

    constructor(props) {
        super(props);

        this.state = {}
    }

    render() {
        const { postId } = this.props;
        const {} = this.state;

        return (
            <>
                <Comments postId={postId} />
                <CommentForm postId={postId} />
            </>
        )
    }

}

// Render component
window.addEventListener("load", () => {
    // Fully loaded!
	const comments = document.getElementById('comments-section');

    if (comments !== null) {
        // CommentsSection form
        ReactDOM.render(<CommentsSection {...comments.dataset} />, comments);
    }
});
