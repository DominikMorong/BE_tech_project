<script lang="ts">
	import { Tipex } from '@friendofsvelte/tipex';
	import '@friendofsvelte/tipex/styles/Tipex.css';
	import '@friendofsvelte/tipex/styles/ProseMirror.css';
	import '@friendofsvelte/tipex/styles/Controls.css';
	import '@friendofsvelte/tipex/styles/EditLink.css';
	import '@friendofsvelte/tipex/styles/CodeBlock.css';

	export let content = `<p>The initial html content.</p>`;
	export let updatedContent;
</script>

<Tipex
	htmlContent={content}
	displayDefaultControls
	floatingMenu
	onEditorUpdate={(content) => (updatedContent = content.editor.getHTML())}
	style="margin-top: 1rem; margin-bottom: 0;"
	className="h-[70vh] border border-neutral-200"
/>
