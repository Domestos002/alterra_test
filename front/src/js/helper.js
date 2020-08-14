export const createDomEl = (html) => {
    const template = document.createElement('template');
    html = html.trim();
    template.innerHTML = html;
    return template.content.firstChild;
};

export const eventDelegate = (parent, event, selector, handler) => {
    parent.addEventListener(event, function(e) {
        for (let target = e.target; target && target !== this; target = target.parentNode) {
            if (target.matches(selector)) {
                handler.call(target, e);
                break;
            }
        }
    }, false);
};


export const serialize = (form) => {
    let requestObj = {};

    form.querySelectorAll('[name]').forEach((elem) => {
        requestObj[elem.name] = elem.value
    });

    if(isEmpty(requestObj)) {
        return false;
    }

    return requestObj;
};


export const isEmpty = (obj) => {
    for(let prop in obj) {
        if(obj.hasOwnProperty(prop)) {
            return false;
        }
    }

    return JSON.stringify(obj) === JSON.stringify({});
};
