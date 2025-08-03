/**
 * DropzoneCard Class
 * Renders an HTML structure for a Dropzone.js file upload area, mimicking AdminLTE's design.
 * This class encapsulates the card, action buttons, progress bars, and file preview template,
 * and handles the Dropzone.js initialization.
 */
class DropzoneCard {
    /**
     * Constructor for the DropzoneCard.
     *
     * @param {string} title The title for the card header.
     * @param {string} subtitle The subtitle for the card header.
     * @param {string} dropzoneId The ID for the main Dropzone area (e.g., the div where Dropzone will be initialized).
     * @param {string} uploadUrl The URL where files will be uploaded (e.g., '/upload-handler.php').
     */
    constructor(title = '', subtitle = '', dropzoneId = 'my-dropzone', uploadUrl = '/upload-target', loadExisting = false, existingImages = []) {
        this.title = title || this._('dropzone_title');
        this.subtitle = subtitle || this._('dropzone_subtitle');
        this.dropzoneId = dropzoneId;
        this.uploadUrl = uploadUrl;
        this.dropzoneInstance = null; // To hold the Dropzone instance
        this.previewTemplate = null; // To hold the parsed template HTML
        this.loadExisting = loadExisting;
        this.existingImages = existingImages;
    }

    /**
     * Helper for translations (equivalent to PHP's _() function).
     * @param {string} key The translation key.
     * @returns {string} The translated string.
     * @private
     */
    _ (key) {
        const translations = {
            'dropzone_add_files': 'إضافة ملفات',
            'dropzone_cancel_upload': 'إلغاء التحميل',
            'start_upload': 'بدأ التحميل',
            'dropzone_start': 'بدء',
            'dropzone_cancel': 'إلغاء',
            'dropzone_delete': 'حذف',
            'dropzone_title': 'تحميل الملفات',
            'dropzone_subtitle': 'اسحب وأفلت الملفات هنا',
        };
        return translations[key] || key;
    }

    /**
     * Helper for HTML escaping to prevent XSS.
     * @param {string} unsafe The unsafe HTML string.
     * @returns {string} The escaped HTML string.
     * @private
     */
    _escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    /**
     * Renders the card header HTML.
     * @returns {string} The HTML string for the header.
     * @private
     */
    _renderHeader() {
        return `
            <div class="card-header">
                <h3 class="card-title">${this._escapeHtml(this.title)} <small><em>${this._escapeHtml(this.subtitle)}</em></small></h3>
            </div>
        `;
    }

    /**
     * Renders the "Add files" button HTML.
     * @returns {string} The HTML string for the button.
     * @private
     */
    _renderAddFilesButton() {
        return `
            <span class="btn btn-success col fileinput-button">
                <i class="fas fa-plus"></i>
                <span>${this._('dropzone_add_files')}</span>
            </span>
        `;
    }

    /**
     * Renders the "Upload files" button HTML.
     * @returns {string} The HTML string for the button.
     * @public
     */
    renderUploadFilesButton() {
        this.uploadFiles =  `
                  <button id="start-upload" type="submit" class="btn btn-primary col start">
                        <i class="fas fa-upload"></i>
                <span>${this._('start_upload')}</span>
                      </button>
        `;
    }

    /**
     * Renders the "Cancel upload" button HTML.
     * @returns {string} The HTML string for the button.
     * @private
     */
    _renderCancelUploadButton() {
        return `
            <button type="reset" class="btn btn-warning col cancel">
                <i class="fas fa-times-circle"></i>
                <span>${this._('dropzone_cancel_upload')}</span>
            </button>
        `;
    }

    /**
     * Renders the "Start" button within the file template HTML.
     * @returns {DropzoneCard} The HTML string for the button.
     * @private
     */
    renderFileStartButton() {
        this.startButton =  `
            <button class="btn btn-primary start">
                <i class="fas fa-upload"></i>
                <span>${this._('dropzone_start')}</span>
            </button>
        `;
        return this;
    }

    /**
     * Renders the "Cancel" button within the file template HTML.
     * @returns {string} The HTML string for the button.
     * @private
     */
    _renderFileCancelButton() {
        return `
            <button data-dz-remove class="btn btn-warning cancel">
                <i class="fas fa-times-circle"></i>
                <span>${this._('dropzone_cancel')}</span>
            </button>
        `;
    }

    /**
     * Renders the "Delete" button within the file template HTML.
     * @returns {string} The HTML string for the button.
     * @private
     */
    _renderFileDeleteButton() {
        return `
            <button data-dz-remove class="btn btn-danger delete">
                <i class="fas fa-trash"></i>
                <span>${this._('dropzone_delete')}</span>
            </button>
        `;
    }

    /**
     * Renders the Dropzone file preview template HTML.
     * This template is usually hidden and cloned by Dropzone.js for each file.
     * @returns {string} The HTML string for the file template.
     * @private
     */
    _renderFileTemplate() {
        return `
            <div id="template" class="row mt-2">
                <div class="col-auto">
                    <span class="preview"><img src="data:," alt="" data-dz-thumbnail/></span>
                </div>
                <div class="col d-flex align-items-center">
                    <p class="mb-0">
                        <span class="lead" data-dz-name></span>
                        (<span data-dz-size></span>)
                    </p>
                    <strong class="error text-danger" data-dz-errormessage></strong>
                </div>
                <div class="col-4 d-flex align-items-center">
                    <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                    </div>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <div class="btn-group">
                        ${this.startButton??''}
                        ${this._renderFileCancelButton()}
                        ${this._renderFileDeleteButton()}
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Renders the card body HTML containing Dropzone actions and previews.
     * @returns {string} The HTML string for the body.
     * @private
     */
    _renderBody() {
        return `
            <div class="card-body">
                <div id="actions" class="row">
                    <div class="col-lg-6">
                        <div class="btn-group w-100">
                            ${this._renderAddFilesButton()}
                            ${this.uploadFiles??''}
                            ${this._renderCancelUploadButton()}
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="fileupload-process w-100">
                            <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="dropzone" id="${this._escapeHtml(this.dropzoneId)}"></div>-->
                <div class="table table-striped files" id="previews">
                    <!-- The template will be dynamically inserted by Dropzone.js after initialization -->
                </div>
            </div>
        `;
    }

    /**
     * Renders the card footer HTML.
     * @returns {string} The HTML string for the footer.
     * @private
     */
    _renderFooter() {
        return `
            <div class="card-footer">
<!--                Visit <a href="https://www.dropzonejs.com">dropzone.js documentation</a>-->
<!--                for more examples and information about the plugin.-->
            </div>
        `;
    }

    /**
     * Returns the full HTML string for the Dropzone card.
     * This HTML should be inserted into the DOM before calling initializeDropzone().
     * @returns {string} The complete HTML string.
     */
    getHtml() {
        return `
            <div class="card card-default">
                ${this._renderHeader()}
                ${this._renderBody()}
                ${this._renderFooter()}
            </div>
        `;
    }

    /**
     * Initializes the Dropzone.js instance and sets up event handlers.
     * This method should be called AFTER the HTML generated by getHtml() is inserted into the DOM.
     */
    initializeDropzone() {
        // Create a temporary div to parse the template HTML
        const tempContainer = document.createElement('div');
        tempContainer.innerHTML = this._renderFileTemplate();
        const previewNode = tempContainer.querySelector("#template");

        if (!previewNode) {
            console.error("Dropzone template #template not found in generated HTML.");
            return;
        }

        // Dropzone.js expects the template to be a string, not a DOM node.
        // It will clone this string. We remove the ID from the string to prevent duplicate IDs.
        previewNode.id = "";
        this.previewTemplate = previewNode.outerHTML;

        // Ensure Dropzone.js library is loaded
        if (typeof Dropzone === 'undefined') {
            console.error("Dropzone.js library not found. Please ensure it's loaded before initializing DropzoneCard.");
            return;
        }

        Dropzone.autoDiscover = false; // Disable auto-discovery to manually initialize

        this.dropzoneInstance = new Dropzone(`#${this.dropzoneId}`, {
            url: this.uploadUrl,
            autoProcessQueue: false,
            uploadMultiple: true,
            // addRemoveLinks: true,
            paramName: "images[]",
            acceptedFiles: "image/*",
            // dictRemoveFile: "حذف الصورة",
            method: "POST",
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: this.previewTemplate,
            autoQueue: false, // Files aren't queued until manually added
            previewsContainer: "#previews", // Container to display previews
            clickable: ".fileinput-button", // Element to trigger file selection
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        // Event listener for when a file is added
        this.dropzoneInstance.on("addedfile", (file) => {
            if (file.previewElement) {
                const startButton = file.previewElement.querySelector(".start");
                if (startButton) {
                    startButton.onclick = () => {
                        this.dropzoneInstance.enqueueFile(file); // Queue the file for upload
                    };
                }
            }
        });

        // Event listener for total upload progress
        this.dropzoneInstance.on("totaluploadprogress", (progress) => {
            const totalProgressBar = document.querySelector("#total-progress .progress-bar");
            if (totalProgressBar) {
                totalProgressBar.style.width = progress + "%";
            }
        });

        // Event listener when a file starts sending
        this.dropzoneInstance.on("sending", (file) => {
            const totalProgressDiv = document.querySelector("#total-progress");
            if (totalProgressDiv) {
                totalProgressDiv.style.opacity = "1"; // Show total progress bar
            }
            if (file.previewElement) {
                const startButton = file.previewElement.querySelector(".start");
                if (startButton) {
                    startButton.setAttribute("disabled", "disabled"); // Disable start button
                }
            }
        });

        // Event listener when the upload queue is complete
        this.dropzoneInstance.on("queuecomplete", (progress) => {
            const totalProgressDiv = document.querySelector("#total-progress");
            if (totalProgressDiv) {
                totalProgressDiv.style.opacity = "0"; // Hide total progress bar
            }
        });

        // Event listener for the global cancel button
        const cancelButton = document.querySelector("#actions .cancel");
        if (cancelButton) {
            cancelButton.onclick = () => {
                this.dropzoneInstance.removeAllFiles(true); // Remove all files from queue
            };
        }

        if (this.loadExisting && this.existingImages.length > 0) {
            this.existingImages.forEach(image => {
                const mockFile = {
                    name: image.path,
                    size: image.size || 1000,
                    serverId: image.id
                };

                this.dropzoneInstance.emit("addedfile", mockFile);
                this.dropzoneInstance.emit("thumbnail", mockFile, assets(image.path)); // الصورة من قاعدة البيانات
                this.dropzoneInstance.emit("complete", mockFile);
                const img = mockFile.previewElement?.querySelector('img[data-dz-thumbnail]');
                if (img) {
                    img.style.width = "80px";
                    img.style.height = "80px";
                    img.style.objectFit = "cover";
                }
                // إضافة زر حذف مخصص
                const deleteButton = mockFile.previewElement.querySelector(".delete");
                if (deleteButton) {
                    deleteButton.onclick = () => {
                        if (confirm("هل تريد حذف هذه الصورة؟")) {
                            fetch(`/admin/projects/images/${mockFile.serverId}/delete`, {
                                method: "DELETE"
                            })
                                .then(res => {
                                    if (res.ok) {
                                        this.dropzoneInstance.removeFile(mockFile);
                                    } else {
                                        alert("فشل في حذف الصورة.");
                                    }
                                });
                        }
                    };
                }
            });
        }

        return this.dropzoneInstance;
    }

}
