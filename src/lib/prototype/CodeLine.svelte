<script lang="ts">
	import highlightjs from 'highlight.js/lib/common'
	import 'highlight.js/styles/github-dark-dimmed.min.css'

	export let language: string
	export let code: string
	export let auto: boolean

	const hl = auto ? highlightjs.highlightAuto(code) : highlightjs.highlight(code, { language })
</script>

<pre><code class="hljs" style="padding: 0 5px;">{@html hl.value}</code></pre>
