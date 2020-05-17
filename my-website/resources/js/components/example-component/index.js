import ReactDOM from 'react-dom';
import React from 'react';

// Import internal dependencies
import FboReactComponent from '../fbo-react-component';
import methods from './methods';
import props from './props';

class ExampleComponent extends FboReactComponent {

    constructor(props) {
        super(props);

        this.state = {}
    }

    render() {
        const {} = this.props;
        const {} = this.state;

        return (
            <>Example component</>
        )
    }

}

export default ExampleComponent;
