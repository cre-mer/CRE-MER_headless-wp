import ReactDOM from 'react-dom';
import React from 'react';

// Import internal dependencies
import FboReactComponent from '../fbo-react-component';
import methods from './methods';
import props from './props';

class CommentForm extends FboReactComponent {

    constructor(props) {
        super(props);

        this.handleSubmit = this.handleSubmit.bind(this);

        this.state = {}
    }

    render() {
        const { postId } = this.props;
        const {} = this.state;

        return (
            <form onSubmit={ this.handleSubmit }>
              <input type="hidden" id="postId" value={postId} />
              <div>
                <label htmlFor="name">Name*</label>
                <input id="name" type="text" required />
              </div>
              <div>
                <label htmlFor="email">Email*</label>
                <input
                  id="email"
                  type="email"
                  required
                />
              </div>
              <div>
                <label htmlFor="comment">Comment*</label>
                <textarea
                  id="comment"
                  required
                />
              </div>
              <input type="submit" value="Post comment!" />
            </form>
        )
    }

    handleSubmit(e) {
      e.preventDefault();

      const [postId, name, email, comment] = e.target.elements;

      const data = JSON.stringify({
        post: postId.value,
        author_name: name.value,
        author_email: email.value,
        content: comment.value,
      });

      const ACTION_URL = "https://api.my-website.test/wp-json/wp/v2/comments"
      fetch(ACTION_URL, {
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
        },
        body: data,
      })
        .then((response) => {
          if (response.ok === true) {
            alert('Submitted successfully!');
          }

          return response.json();
        })
        .then((object) => {
          // Comment submission failed.
          // Output `object.message` to see the error message.
        })
        .catch(error => console.error('Error:', error));
    }

}

export default CommentForm;
