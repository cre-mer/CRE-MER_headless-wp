import ReactDOM from 'react-dom';
import React from 'react';

// Import internal dependencies
import FboReactComponent from '../fbo-react-component';

class CommentForm extends FboReactComponent {

    constructor(props) {
        super(props);

        this.handleSubmit = this.handleSubmit.bind(this);

        this.state = {
            message: undefined
        }
    }

    render() {
        const { postId } = this.props;
        const { message } = this.state;

        return (
            <div>
                { !message ? '' : <p>{message}</p> }
    			<form onSubmit={ this.handleSubmit } className="comments-form">
    				<input type="hidden" id="csrd_token" name="_token" value={CSRF} />
    				<input type="hidden" id="postId" value={postId} />
    				<div>
    					<label htmlFor="name">Name*</label>
    					<input id="name" name="name" type="text" required />
    				</div>
    				<div>
    					<label htmlFor="email">Email*</label>
    					<input id="email" name="email" type="email" required />
    				</div>
    				<div>
    					<label htmlFor="comment">Comment*</label>
    					<textarea id="comment" name="comment" required />
    				</div>
    				<input type="submit" value="Post comment!" />
    			</form>
            </div>
        )
    }

    handleSubmit(e) {
      e.preventDefault();

      const [csrd_token, postId, name, email, comment] = e.target.elements;

      const data = JSON.stringify({
		csrf_token: csrd_token.value,
        post: postId.value,
        author_name: name.value,
        author_email: email.value,
        content: comment.value,
      });

      fetch(ACTION_URL, {
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
        },
        body: data,
      })
        .then((response) => {
            if (response.ok === true) this.setState({message: 'Submitted successfully!'})

            return response.json();
        })
        .then((object) => {
            // Comment submission failed.
            // Output `object.message` to see the error message.
            if (object.message !== undefined) this.setState({message: object.message});
        })
        .catch(error => console.error('Error:', error));
    }

}

export default CommentForm;
