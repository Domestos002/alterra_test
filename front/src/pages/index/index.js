import style from "./index.sass";

import toastr from "toastr";
import contactList from "@js/contact-list";
import contactForm from "@js/contact-form";

toastr.options.timeOut = 3000;
toastr.options.extendedTimeOut = 6000;

document.addEventListener("DOMContentLoaded", function() {
    let list = contactList();
    list.init();

    contactForm({
        createCallback: () => {
            list.getAndUpdate()
        }
    }).init();
});
