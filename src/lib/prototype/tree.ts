import { writable, type Writable } from 'svelte/store'
import { setContext, getContext } from 'svelte'

export type TreeData = {
	id: string
	title: string
	isDir: boolean
	children: TreeData[]
	code: string
	language: string
}

type CodeViewerState = TreeData & {
	markLine?: number
}
export const initCodeViewer = () => {
	const initial = {
    id: '',
    title: '',
    isDir: false,
    children: [],
    code: '',
    language: '',
	}
	setContext('codeViewer', writable<CodeViewerState>(initial))
}
export const useCodeViewer = () => {
	return getContext<Writable<CodeViewerState>>('codeViewer')
}
