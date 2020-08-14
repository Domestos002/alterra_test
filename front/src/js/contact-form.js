import {serialize} from "@js/helper";
import axios from "axios";
import toastr from "toastr";
import IMask from 'imask';

export default (options) => {
    return {
        form: document.querySelector('#taskForm'),
        createCallback: options.createCallback,

        init() {
            IMask(document.querySelector('.js-phone-mask'), {
                mask: '+{7}(000)000-00-00'
            });

            this.form.addEventListener('submit', (e) => {
                e.preventDefault();

                let formData = serialize(e.target);

                if(formData) {
                    axios({
                        method: "POST",
                        url: `${location.origin}/api/contact/create`,
                        data: formData
                    })
                    .then(() => {
                        this.createCallback();
                        toastr.clear();
                        toastr.success('Контакт добавлен');
                        e.target.reset();
                    })
                    .catch(function (error) {
                        switch(error.response.status) {
                            case 303:
                                toastr.clear();
                                error.response.data.forEach(error => toastr.error(error));
                                break;
                            case 500:
                                toastr.warning(status.code);
                                break;
                            default:
                                break;
                        }
                    })
                }
            })
        }
    }
}
