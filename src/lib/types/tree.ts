import type { Unit } from './config'

export type TreeData = {
	id: string
	title: string
	children: TreeData[]
	code: string
	language: string
}

export type UnitWithTreeData = Unit & { files: TreeData[] }
