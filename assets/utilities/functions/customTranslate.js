function customTranslate(key, params) {
    var result = "";
    if (!window.siteTranslation) {
        return result;
    }

    if (!key) {
        return result;
    }

    if (window.siteTranslation[key] === undefined) {
        return result;
    }

    result = window.siteTranslation[key];

    if (
        params !== null &&
        typeof params === "object"
    ) {
        for (var param_key in params) {
            var real_param = "{{" + param_key + "}}";
            result = result.replaceAll(real_param, params[param_key]);
        }
    }

    /* MAJ Too src\Object\CustomTranslationObject::customTranslate */

    return result
}

export { customTranslate }