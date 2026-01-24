import type { Route } from './+types/home'

type Post = {
  id: number
  userId: number
  title: string
  body: string
}

export async function clientLoader({}: Route.ClientLoaderArgs) {
  const res = await fetch(`https://jsonplaceholder.typicode.com/posts/1`)
  const resbody = await res.json()
  return resbody as Post
}

export default function Home({ loaderData }: Route.ComponentProps) {
  const { title, body } = loaderData

  return (
    <div className='mx-auto max-w-4/5'>
      <div className='text-amber-300'>{title}</div>
      <div>{body}</div>
    </div>
  )
}
