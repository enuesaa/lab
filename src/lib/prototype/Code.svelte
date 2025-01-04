<script lang="ts">
	// see https://github.com/metonym/svelte-highlight/issues/246
	import highlightjs from 'highlight.js/lib/common'
	import 'highlight.js/styles/github-dark-dimmed.min.css'
	import CodeLine from './CodeLine.svelte'

	export let language: string
	export let code: string
	export let showLineNumber = false
	export let markLine: number|undefined = undefined

	const lines = code.split('\n')
	const useAuto = highlightjs.getLanguage(language) === undefined
</script>

{#if showLineNumber}
	<table>
		<tbody>
			{#each lines as line, i}
				<tr>
					<td class="lineNumber">{i+1}</td>
					<td class={markLine !== undefined && markLine-1 === i ? 'mark' : ''}>
						<CodeLine code={line} {language} auto={useAuto} />
					</td>
				</tr>
			{/each}
		</tbody>
	</table>
{:else}
	<CodeLine {code} {language} auto={useAuto} />
{/if}

<style lang="postcss">
	table {
		@apply w-full;
	}
	tbody {
		@apply py-2 block bg-editorbg text-editortext pl-3;
	}
	td {
		@apply p-0;

		&.lineNumber {
			@apply text-gray-600 opacity-65 min-w-7 text-base text-center;
			@apply select-none pr-2;
		}
		&.mark {
			@apply w-full relative;
		}
		&.mark::after {
			content: '\00a0';
			animation: markAnimation 3s forwards;
			@apply absolute top-0 left-0 w-full;
		}
	}

	@keyframes markAnimation {
		0% {
			@apply bg-orange-500/30
		}
		90% {
			@apply bg-orange-500/30
		}
		100% {
			@apply bg-transparent;
		}
	}
</style>
