import $ from 'jquery';

class MyNotes {
    // constructor
    constructor() {
        this.events();
    }

    // event
    events() {
        $("#my-notes").on("click", ".delete-note", this.deleteNote);
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this));
        $(".submit-note").on("click", this.createNote.bind(this));
    }

    // methods
    createNote(data) {
        var newPost = {
            'title': $(".new-note-title").val(),
            'content': $(".new-note-body").val(),
            'status': 'private'
        };

        $.ajax({ // => ajax is a great option when you want to control what type of the request you sending
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', esvData.nonce);
            },
            url: esvData.root_url + '/wp-json/wp/v2/note/', // '/wp-json/wp/v2/note/' -> to create a new post type of note; '/wp-json/wp/v2/posts/' -> to create a new post type of posts ...
            type: 'POST', // -> POSTING or SENDING data
            data: newPost,
            success: (response) => {
                $(".new-note-title, new-note-body").val('');
                $(`
                    <li data-id="${response.id}">
                        <input readonly class="note-title-field" value="${response.title.raw}">
                        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Bearbeiten</span>
                        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Löschen</span>
                        <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Speichern</span>
                    </li>
                `).prependTo("#my-notes").hide().slideDown();
                console.log("Congrats");
                console.log(response);
            },
            error: (response) => {
                console.log("Sorry");
                console.log(response);
            }
        }); 
    }

    updateNote(data) {
        var currentNote = $(data.target).parents("li");

        var updatedPost = {
            'title': currentNote.find(".note-title-field").val(),
            'content': currentNote.find(".note-body-field").val()
        };

        $.ajax({ // => ajax is a great option when you want to control what type of the request you sending
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', esvData.nonce);
            },
            url: esvData.root_url + '/wp-json/wp/v2/note/' + currentNote.data('id'),
            type: 'POST',
            data: updatedPost,
            success: (response) => {
                this.makeNoteReadonly(currentNote);
                console.log("Congrats");
                console.log(response);
            },
            error: (response) => {
                console.log("Sorry");
                console.log(response);
            }
        }); 
    }

    editNote(data) {
        var currentNote = $(data.target).parents("li");

        if (currentNote.data("state") == "editable") {
            this.makeNoteReadonly(currentNote);
        } else {
            this.makeNoteEditable(currentNote);
        }
    }

    makeNoteEditable(currentNote) {
        currentNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Abbrechen');
        currentNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        currentNote.find(".update-note").addClass("update-note--visible");

        currentNote.data("state", "editable");
    }

    makeNoteReadonly(currentNote) {
        currentNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i> Bearbeiten');
        currentNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        currentNote.find(".update-note").removeClass("update-note--visible");

        currentNote.data("state", "readonly");
    }

    deleteNote(data) {
        var currentNote = $(data.target).parents("li");

        $.ajax({ // => ajax is a great option when you want to control what type of the request you sending
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', esvData.nonce);
            },
            url: esvData.root_url + '/wp-json/wp/v2/note/' + currentNote.data('id'),
            type: 'DELETE',
            success: (response) => {
                currentNote.slideUp();
                console.log("Congrats");
                console.log(response);
            },
            error: (response) => {
                console.log("Sorry");
                console.log(response);
            }
        }); 
    }

}

export default MyNotes;