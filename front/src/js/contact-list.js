import axios from "axios";
import {createDomEl, eventDelegate} from "@js/helper";
import toastr from "toastr";

export default () => {
    return {
        container: document.querySelector('#taskList'),
        list: null,

        createDomItem({name, phone, id}) {
            this.list.appendChild(createDomEl(`
            <div class="contact__item title">
                <p class="contact__name">${ name } <span class="contact__delete" data-record="${ id }">×</span></p>
                <a href="tel:${phone}" class="contact__phone">${ phone }</a>
            </div>
            `));
        },

        deleteRecord(id) {
            return axios({
                method: "POST",
                url: `${location.origin}/api/contact/delete/${id}`,
            }).then(response => response.data);
        },

        getAndUpdate() {
            axios({
                method: "GET",
                url: `${location.origin}/api/contact/index`,
            }).then(response => {
                if(this.list != null) {
                    this.list.remove();
                    this.list = null;
                }

                this.list = createDomEl(`<div class="contact__list"></div>`);

                this.container.innerHTML = '';
                this.container.appendChild(this.list);
                response.data.forEach(el => this.createDomItem(el))
            });
        },

        init() {
            this.getAndUpdate();

            eventDelegate(this.container, 'click', '.contact__delete', (e) => {
                let recordId = e.target.getAttribute('data-record');
                if(recordId != null) {
                    this.deleteRecord(recordId).then(() => {
                        toastr.clear();
                        toastr.success('Контакт удален');
                        this.getAndUpdate();
                    })
                }
            })
        }
    }
}
