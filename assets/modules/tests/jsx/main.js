import TestJsx from "vue/components/modules/tests/TestJsx/TestJsx.jsx"
import { setChildView } from "vue/helper/renderVue.js"
import { getConfig } from "./config.js"

function main() {
	setChildView(
        "#app_body_wrapper", 
        TestJsx, 
        getConfig().component
    );
}

export { main };