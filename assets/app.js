

import './styles/app.scss';
import { Dropdown } from 'bootstrap';
import { format } from 'date-fns';
import { fr } from 'date-fns/locale';

document.addEventListener('DOMContentLoaded', () => {
    enableDropdown();

    const maDate = new Date();
    const dateEnFrancais = format(maDate, 'dd MMMM yyyy', { locale: fr });

    console.log(`Date en français : ${dateEnFrancais}`);
});



const enableDropdown = () => {
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownElementList.map(function (dropdownToggleEl) {
        return new Dropdown(dropdownToggleEl);
    });
};
