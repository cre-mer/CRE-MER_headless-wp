import React from 'react';

class FboReactComponent extends React.Component {
  constructor(props) {
    super(props);
  }

  componentDidCatch(error, errorInfo) {
    // You can also log the error to an error reporting service
    console.error(error, errorInfo);
  }

}

export default FboReactComponent;
