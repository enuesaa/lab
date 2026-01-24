import type { Route } from './+types/home'

type Info = {
  version: string
  message: string
}

export async function clientLoader({}: Route.ClientLoaderArgs) {
  // const res = await fetch(`https://jsonplaceholder.typicode.com/posts/1`)
  const res = await fetch('/api/info')
  const resbody = await res.json()
  return resbody as Info
}

export default function Home({ loaderData }: Route.ComponentProps) {
  const { version, message } = loaderData

  return (
    <div className="w-96 p-6 my-5 mx-auto rounded-xl border border-white/10 bg-white/5">
      a{message} <br />
      (version: b{version})
    </div>
  )
}
