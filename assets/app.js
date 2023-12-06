

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



function deleteComment(commentId) {
    if (confirm("Voulez-vous vraiment supprimer ce commentaire ?")) {
        fetch(`/comment/delete/${commentId}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (response.ok) {
                    console.log(data.message);
                    const commentElement = document.getElementById(`comment-${commentId}`);
                    if (commentElement) {
                        commentElement.remove();
                    } else {
                        console.error("Élément du commentaire non trouvé dans le DOM.");
                    }
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error("Erreur lors de la suppression du commentaire :", error);
            });
    }
}


document.addEventListener('DOMContentLoaded', function() {
    var links = document.querySelectorAll('a[href^="http"]:not([href*="' + window.location.host + '"])');
  
    links.forEach(function(link) {
      link.addEventListener('click', function(event) {
        event.preventDefault();
        window.open(link.href, '_blank');
      });
    });
  });
  









