import { getUnitFiles } from '$lib/prototype/server/files'
import { getProject } from '$lib/prototype/server/project'
import { error } from '@sveltejs/kit'

const description = `curl ライクな CLI を作ってみる。

とは言っても GET しかできない。
curl とは似ても似つかないが、まあサンプルなので良いと思う。`

const terminal = `$ go run . -url https://example.com/
<!doctype html>
<html>
<head>
    <title>Example Domain</title>
    
// 省略
// example.com へ HTTP GET リクエストをして、レスポンスボディを標準出力する`

const description3 = `cmdfx.New() を見ると分かる通り、cmdfx.ICmd は clientfx.IClient へ依存している。
この依存の注入を fx がしてくれる。

cmdfx と clientfx は interface を介してやり取りしているのがポイント。
これにより例えば mock へ差し替えできる。`



export const load = async () => {
	if (import.meta.env.PROD) {
		error(404, 'Page not found')
	}

	const project = await getProject('go-fx-di-httpcall-cli')
	const unitfiles = await getUnitFiles(project)

	return { project, files: unitfiles['コード全体'] }
}
