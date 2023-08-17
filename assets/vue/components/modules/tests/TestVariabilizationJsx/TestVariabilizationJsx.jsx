import { C } from "vue/helper/V02Component.jsx";
import classNames from "classnames";
import styles from "./TestVariabilizationJsx.scss?module";

export default C.make({
    $render() {
        return (
            <div class={classNames("container")}>
                <h1>
                    {customTranslate("tests.pages.page2.content.title.text")}
                </h1>

                <h2>
                    {customTranslate(
                        "tests.pages.page2.content.subtitle.text1",
                        { firstname: "Janne", lastname: "Clark" },
                    )}
                </h2>

                <p
                    domPropsInnerHTML={customTranslate(
                        "tests.pages.page2.content.description.text",
                        { firstname: "Janne" },
                    )}
                ></p>

                <img
                    src={customTranslate("tests.pages.page2.content.img.src")}
                    class="rounded mx-auto d-block max_w_128 mb-3"
                    alt={customTranslate("tests.pages.page2.content.img.alt")}
                />

                <span class="background_img max_w_128 mb-3"></span>
            </div>
        );
    },
});
