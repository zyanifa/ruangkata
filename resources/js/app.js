import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
window.Alpine = Alpine;

Alpine.start();

/**
 * This configuration was generated using the CKEditor 5 Builder. You can modify it anytime using this link:
 * https://ckeditor.com/ckeditor-5/builder/#installation/NoNgNARATAdArDADBSBGRVVwJzYMxQAcALFAQOzlmoiJ7HnG42GF4iFGrkkoQCmAOxSIwwVGFFTJYVAF1IAEygAjMnkIQ5QA
 */

const {
	ClassicEditor,
	Alignment,
	Autoformat,
	AutoImage,
	Autosave,
	BlockQuote,
	Bold,
	Code,
	CodeBlock,
	Essentials,
	FindAndReplace,
	FontBackgroundColor,
	FontColor,
	FontFamily,
	FontSize,
	Heading,
	Highlight,
	ImageBlock,
	ImageCaption,
	ImageEditing,
	ImageInline,
	ImageInsert,
	ImageInsertViaUrl,
	ImageResize,
	ImageStyle,
	ImageTextAlternative,
	ImageToolbar,
	ImageUpload,
	ImageUtils,
	Indent,
	IndentBlock,
	Italic,
	Link,
	LinkImage,
	List,
	ListProperties,
	MediaEmbed,
	Paragraph,
	PasteFromOffice,
	SimpleUploadAdapter,
	SpecialCharacters,
	SpecialCharactersArrows,
	SpecialCharactersCurrency,
	SpecialCharactersEssentials,
	SpecialCharactersLatin,
	SpecialCharactersMathematical,
	SpecialCharactersText,
	Strikethrough,
	Subscript,
	Superscript,
	Table,
	TableCaption,
	TableCellProperties,
	TableColumnResize,
	TableProperties,
	TableToolbar,
	Underline
} = window.CKEDITOR;

/**
 * This is a 24-hour evaluation key. Create a free account to use CDN: https://portal.ckeditor.com/checkout?plan=free
 */
const LICENSE_KEY =
	'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzY5MDIzOTksImp0aSI6IjgwNjBiODM1LWM3ZjMtNDAyYi1iMTFjLTZhNzljY2RjN2M1ZiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6ImMyNjk1YWIwIn0.M5hzqhrkOGU6fWZOd0pg5qzqjdxN9PnXRDtZfshmZ7D3kv2hc3nUxZnw_MNKHhmV_Vt7xfhvPiskwg2VoJw7nw';

const editorConfig = {
	toolbar: {
		items: [
			'findAndReplace',
			'|',
			'heading',
			'|',
			'fontSize',
			'fontFamily',
			'fontColor',
			'fontBackgroundColor',
			'|',
			'bold',
			'italic',
			'underline',
			'strikethrough',
			'subscript',
			'superscript',
			'code',
			'|',
			'specialCharacters',
			'link',
			'insertImage',
			'mediaEmbed',
			'insertTable',
			'highlight',
			'blockQuote',
			'codeBlock',
			'|',
			'alignment',
			'|',
			'bulletedList',
			'numberedList',
			'outdent',
			'indent'
		],
		shouldNotGroupWhenFull: true
	},
	plugins: [
		Alignment,
		Autoformat,
		AutoImage,
		Autosave,
		BlockQuote,
		Bold,
		Code,
		CodeBlock,
		Essentials,
		FindAndReplace,
		FontBackgroundColor,
		FontColor,
		FontFamily,
		FontSize,
		Heading,
		Highlight,
		ImageBlock,
		ImageCaption,
		ImageEditing,
		ImageInline,
		ImageInsert,
		ImageInsertViaUrl,
		ImageResize,
		ImageStyle,
		ImageTextAlternative,
		ImageToolbar,
		ImageUpload,
		ImageUtils,
		Indent,
		IndentBlock,
		Italic,
		Link,
		LinkImage,
		List,
		ListProperties,
		MediaEmbed,
		Paragraph,
		PasteFromOffice,
		SimpleUploadAdapter,
		SpecialCharacters,
		SpecialCharactersArrows,
		SpecialCharactersCurrency,
		SpecialCharactersEssentials,
		SpecialCharactersLatin,
		SpecialCharactersMathematical,
		SpecialCharactersText,
		Strikethrough,
		Subscript,
		Superscript,
		Table,
		TableCaption,
		TableCellProperties,
		TableColumnResize,
		TableProperties,
		TableToolbar,
		Underline
	],

    // Disable Markdown output
    markdown: false,

	fontFamily: {
		supportAllValues: true
	},
	fontSize: {
		options: [10, 12, 14, 'default', 18, 20, 22],
		supportAllValues: true
	},
	heading: {
		options: [
			{
				model: 'paragraph',
				title: 'Paragraph',
				class: 'ck-heading_paragraph'
			},
			{
				model: 'heading1',
				view: 'h1',
				title: 'Heading 1',
				class: 'ck-heading_heading1'
			},
			{
				model: 'heading2',
				view: 'h2',
				title: 'Heading 2',
				class: 'ck-heading_heading2'
			},
			{
				model: 'heading3',
				view: 'h3',
				title: 'Heading 3',
				class: 'ck-heading_heading3'
			},
			{
				model: 'heading4',
				view: 'h4',
				title: 'Heading 4',
				class: 'ck-heading_heading4'
			},
			{
				model: 'heading5',
				view: 'h5',
				title: 'Heading 5',
				class: 'ck-heading_heading5'
			},
			{
				model: 'heading6',
				view: 'h6',
				title: 'Heading 6',
				class: 'ck-heading_heading6'
			}
		]
	},
	image: {
		toolbar: [
			'toggleImageCaption',
			'imageTextAlternative',
			'|',
			'imageStyle:alignLeft', 
			'imageStyle:alignCenter',
			'imageStyle:alignRight',
			'|',
			'resizeImage'
		],
		styles: {
			options: [
				'alignLeft',
				'alignCenter',
				'alignRight',
				'block',
				'side'
			]
		}
	},
	licenseKey: LICENSE_KEY,
	link: {
		addTargetToExternalLinks: true,
		defaultProtocol: 'https://',
		decorators: {
			toggleDownloadable: {
				mode: 'manual',
				label: 'Downloadable',
				attributes: {
					download: 'file'
				}
			}
		}
	},
	list: {
		properties: {
			styles: true,
			startIndex: true,
			reversed: true
		}
	},
	placeholder: 'Ketik konten Anda di sini!',
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
	},

	simpleUpload: {
        // The URL that the images are uploaded to.
        uploadUrl: '/upload-image',

        // Headers sent along with the XMLHttpRequest to the upload server.
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },

};

// Update your ClassicEditor.create call with this:

ClassicEditor.create(document.querySelector('#editor'), {
    ...editorConfig,
    // Add these properties:
    ui: {
        viewportOffset: { top: 10, right: 10, bottom: 10, left: 10 }
    }
})
.then(editor => {
    // Apply content styles to the editing area
    const editorElement = editor.ui.view.editable.element;
    editorElement.classList.add('ck-content');
    
    // Update the form before submission
    document.querySelector('form').addEventListener('submit', function(e) {
        // Update the textarea with the editor content
        editor.updateSourceElement();
    });
})
.catch(error => {
    console.error(error);
});
