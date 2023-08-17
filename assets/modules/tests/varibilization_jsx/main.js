import TestVariabilizationJsx from "vue/components/modules/tests/TestVariabilizationJsx/TestVariabilizationJsx.jsx"
import { setChildView } from "vue/helper/renderVue.js"
import { getConfig } from "./config.js"

function main() {
	setChildView(
        "#app_body_wrapper", 
        TestVariabilizationJsx, 
        getConfig().component
    );
}

export { main };