<script lang="ts">
	import type { CodeFiles, ProjectV2, UnitV2 } from '$lib/prototype/types'
	import UnitSep from '../prototype/[name]/UnitSep.svelte'
	import CodeViewer from './CodeViewer.svelte'

	export let project: ProjectV2
	export let codeFiles: CodeFiles
</script>

<div class="w-7/12">
	<div class="rounded-lg overflow-hidden">
		<UnitSep text="</>" treeData={codeFiles} enableDownloader />
		<CodeViewer treeData={codeFiles} firstOpen={project.code?.open ?? ''} />
	</div>
</div>
