import { parseAttrs } from '$lib/prototype/attrs'
import type { TreeData } from '$lib/prototype/tree'
import type { CodeFiles, CodeUnit, ProjectV2, UnitV2 } from '$lib/prototype/types'

const flattenFiles = (files: CodeFiles): TreeData[] => {
	const ret: TreeData[] = []
	for (const file of files) {
		if (file.isDir) {
			ret.push(...flattenFiles(file.children))
			continue
		}
		ret.push(file)
	}
	return ret
}

const renderLinks = (links?: { title: string; url: string }[]): string => {
	if (links === undefined || links.length === 0) {
		return ''
	}
	return links.map((link) => `- [${link.title}](${link.url})`).join('\n') + '\n'
}

const renderInline = (inline?: UnitV2['inline']): string => {
	if (inline?.file === undefined) {
		return ''
	}
	return '```' + inline.file.language + '\n' + inline.file.code + '\n```\n\n'
}

const renderImage = (projectName: string, image: string): string => {
	const { content: filename } = parseAttrs(image)
	return `![${filename}](https://lab.enuesaa.dev/prototype/${projectName}/${filename})\n\n`
}

const renderCodeUnit = (unit: CodeUnit): string => {
	let out = ''
	if (unit.title !== undefined) {
		out += `**${unit.title}**\n\n`
	}
	if (unit.description !== undefined) {
		out += `${unit.description}\n\n`
	}
	if (unit.mark !== undefined) {
		out += `mark: \`${unit.mark}\`\n\n`
	}
	if (unit.terminal !== undefined) {
		out += '```bash\n' + unit.terminal + '\n```\n\n'
	}
	out += renderInline(unit.inline)
	out += renderLinks(unit.links)
	return out
}

const renderCodeSection = (projectName: string, unit: UnitV2): string => {
	if (unit.code === undefined) {
		return ''
	}
	let out = `## ${unit.title ?? 'コード'}\n\n`

	for (const file of flattenFiles(unit.code.files ?? [])) {
		out += `### \`${file.id}\`\n\n`
		out += '```' + file.language + '\n' + file.code + '\n```\n\n'
	}

	const codeUnits = unit.code.units ?? []
	if (codeUnits.length > 0) {
		out += '### memos\n\n'
		for (const codeUnit of codeUnits) {
			out += renderCodeUnit(codeUnit)
		}
	}

	return out
}

const renderPlainSection = (projectName: string, unit: UnitV2): string => {
	let out = ''
	if (unit.cap !== undefined) {
		out += `**${unit.cap}**\n\n`
	}
	if (unit.title !== undefined) {
		out += `## ${parseAttrs(unit.title).content}\n\n`
	}
	if (unit.description !== undefined) {
		out += `${unit.description}\n\n`
	}
	out += renderLinks(unit.links)
	if (unit.outline !== undefined) {
		out += `${unit.outline.title ?? 'outline'}\n\n`
		out += unit.outline.items.map((item) => `- ${item.title}`).join('\n') + '\n\n'
	}
	if (unit.image !== undefined) {
		out += renderImage(projectName, unit.image)
	}
	if (unit.terminal !== undefined) {
		out += '```bash\n' + unit.terminal + '\n```\n\n'
	}
	out += renderInline(unit.inline)
	return out
}

export const buildProjectMarkdown = (project: ProjectV2): string => {
	let out = `# ${project.title}\n\n`
	out += `published: ${project.published}\n\n`
	if (project.description) {
		out += `${project.description}\n\n`
	}
	for (const unit of project.units) {
		out += unit.code !== undefined ? renderCodeSection(project.name, unit) : renderPlainSection(project.name, unit)
	}
	return out
}
