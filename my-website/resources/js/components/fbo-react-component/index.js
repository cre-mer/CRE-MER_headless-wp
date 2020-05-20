import React from 'react';

class FboReactComponent extends React.Component {
	constructor(props) {
		super(props);

		this.dangerousHTML = this.dangerousHTML.bind(this);
	}

	componentDidCatch(error, errorInfo) {
		// You can also log the error to an error reporting service
		console.error(error, errorInfo);
	}

	/*
	 * WARNING: I sure hope you know what you are doing.
	 * ~ quote by: npm ~
	 */
	dangerousHTML(html) {
		return {__html: html};
	}
}

export default FboReactComponent;
