import { C } from "vue/helper/V02Component.jsx";
import classNames from "classnames";
import styles from "./TestJsx.scss?module";

export default C.make({
    renderTitle() {
        return (
            <h1 class="title">
                JSX
            </h1>
        )
    },
    $render() {
        return (
            <div class={classNames("text-center", styles.container)}>
                { this.renderTitle() }
                <div class="blk_img"></div>
                <div class={classNames(styles.blk_img)}></div>
            </div>
        );
    },
});
