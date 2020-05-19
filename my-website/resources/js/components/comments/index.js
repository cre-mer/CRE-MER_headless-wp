import ReactDOM from 'react-dom';
import React from 'react';

// Import internal dependencies
import FboReactComponent from '../fbo-react-component';

class Comments extends FboReactComponent {

	constructor(props) {
		super(props);

		this.getComments = this.getComments.bind(this);
		this.getTotalComments = this.getTotalComments.bind(this);

		this.state = {
			comments: [],
			max_per_page: 100,
			page: 1,
			per_page: 5,
			show_less_comments: true,
			total_comments: 0
		}
	}

	componentDidMount() {
		this.getTotalComments();
		this.getComments();
	}

	render() {
		const {comments, page, per_page, show_less_comments, total_comments} = this.state;

		console.log(total_comments , per_page);

		return (
			<ol className="comments">
				{ comments.length == 0 ? 'There are no comments yet.' :
					comments.map((comment, key) => {
						return (
							<li key={key}>
								<article>
									<address>{comment.author_name}</address>
									<div dangerouslySetInnerHTML={this.dangerousHTML(comment.content.rendered)}></div>
								</article>
							</li>
						)
					})
				}
				{ total_comments <= per_page && !show_less_comments ? '' : total_comments <= per_page ?
					<a href="#" onClick={() => {this.setState({total_comments: total_comments + per_page}); this.showLessComments()}}>Show less comments</a>
					:
					<a href="#" onClick={() => {this.setState({total_comments: total_comments - per_page}); this.getComments()}}>Show older comments</a>
				}
			</ol>
		)
	}

	getComments() {
		const {postId} = this.props;
		const {comments, page, per_page, total_comments} = this.state;

		fetch(ACTION_URL + `?post=${postId}&per_page=${per_page}&page=${page}`, {
			method: 'get',
			headers: {
			'Content-Type': 'application/json',
			}
		})
		.then((response) => {
			return response.json();
		})
		.then((object) => {
			var newComments = object;
			this.setState({
				comments: [...comments, ...newComments],
				page: page + 1,
				show_less_comments: total_comments > per_page
			});
		})
		.catch(error => console.error('Error:', error));
	}

	getTotalComments() {
		const {postId} = this.props;
		const {max_per_page} = this.state;

		fetch(ACTION_URL + `?post=${postId}&per_page=${max_per_page}`, {
			method: 'get',
			headers: {
			'Content-Type': 'application/json',
			}
		})
		.then((response) => {
			return response.json();
		})
		.then((object) => {
			this.setState({
				total_comments: object.length,
			});
		})
		.catch(error => console.error('Error:', error));
	}

	showLessComments() {
		const { comments, per_page } = this.state;

		var newComments = comments;
		this.setState({
			comments: newComments.splice(0, per_page),
			page: 2
		});
		this.getTotalComments();
	}

}

export default Comments;
