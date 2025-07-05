<script lang="ts">
  const isDev = import.meta.env.DEV
</script>

<svelte:head>
  {#if !isDev}
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-M85LPSR46E"></script>
    <script>
      window.dataLayer = window.dataLayer || []
      function gtag() {
        dataLayer.push(arguments)
      }
      gtag('js', new Date())
      gtag('config', 'G-M85LPSR46E')
    </script>
  {/if}
</svelte:head>
