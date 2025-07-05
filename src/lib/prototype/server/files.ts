import fs from 'node:fs/promises'
import path from 'node:path'
import type { TreeData } from '$lib/prototype/tree'
import type { ProjectV2 } from '$lib/prototype/types'

export const extractCodeFiles = async (project: ProjectV2): Promise<ProjectV2> => {
	for (let i = 0; i < project.units.length; i++) {
		const unit = project.units[i]
		if (unit.code === undefined || unit.code.open === undefined) {
			continue
		}

		const include = unit.code?.include ?? []
		include.push(unit.code?.open) // by default

		unit.code.files = await extract(`./data/${project.name}`, '', include)
		project.units[i] = unit
	}
	return project
}

export const extractInlineFile = async (project: ProjectV2): Promise<ProjectV2> => {
	for (let i = 0; i < project.units.length; i++) {
		const unit = project.units[i]
		if (unit.inline === undefined || unit.inline.open === undefined) {
			continue
		}

		const files = await extract(`./data/${project.name}`, '', [unit.inline.open])
		if (files.length > 0) {
			unit.inline.file = files[0]
			project.units[i] = unit
		}
	}
	return project
}

const extract = async (dir: string, baseDir: string = '', include: string[]): Promise<TreeData[]> => {
	const ret: TreeData[] = []
	const files = await fs.readdir(dir, { withFileTypes: true })

	for (const f of files) {
		const filepath = path.join(dir, f.name)
		const relpath = path.join(baseDir, f.name)

		if (f.isDirectory()) {
			const children = await extract(filepath, relpath, include)
			if (children.length > 0) {
				ret.push({
					id: relpath,
					title: f.name,
					isDir: true,
					children,
					code: '',
					language: '',
					// ディレクトリが列挙されていたらデフォルトで開く
					expanded: include.includes(relpath),
				})
			}
			continue
		}

		if (!include.includes(relpath)) {
			continue
		}

		const language = f.name.split('.').at(-1) ?? ''
		const code = await fs.readFile(filepath, 'utf8')
		ret.push({
			id: relpath,
			title: f.name,
			isDir: false,
			children: [],
			code,
			language,
		})
	}

	// order by `include`
	ret.sort((a, b) => {
		let ai = include.indexOf(a.id)
		let bi = include.indexOf(b.id)
		if (ai === -1) {
			const child = findchild(a)
			ai = include.indexOf(child.id)
		}
		if (bi === -1) {
			const child = findchild(b)
			bi = include.indexOf(child.id)
		}
		return ai - bi
	})

	return ret
}

const findchild = (data: TreeData): TreeData => {
	if (data.isDir && data.children.length > 0) {
		return findchild(data.children[0])
	}
	return data
}
