import { createTreeView } from '@melt-ui/svelte'
import { writable, type Writable } from 'svelte/store'
import { setContext, getContext } from 'svelte'
import type { Unit } from './server/prototype/types'

export type TreeData = {
	id: string
	title: string
	children: TreeData[]
	code: string
	language: string
}
export type UnitWithTreeData = Unit & { files: TreeData[] }

export const createTreeViewCtl = () => {
	setContext('treeView', createTreeView())
}
export const getTreeViewCtl = () => {
	const treeView = getContext<ReturnType<typeof createTreeView>>('treeView')
	return treeView.elements
}
export const createViewing = () => {
	setContext('viewing', writable<TreeData | undefined>(undefined))
}
export const getViewing = () => {
	return getContext<Writable<TreeData | undefined>>('viewing')
}
