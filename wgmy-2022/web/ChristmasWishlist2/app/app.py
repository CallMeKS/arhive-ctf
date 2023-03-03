from flask import Flask, request, render_template, render_template_string
from waitress import serve
import os
import subprocess

app_dir = os.path.split(os.path.realpath(__file__))[0]
app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = f'{app_dir}/upload/'

@app.route('/', methods=['GET','POST'])
def index():
	try:
		if request.method == 'GET':
			return render_template('index.html')

		elif request.method == 'POST':
			f = request.files['file']
			filepath = os.path.join(app.config['UPLOAD_FOLDER'], f.filename)

			if os.path.exists(filepath) or ".." in filepath:
				return render_template_string("Hohoho.. No present for you")
			
			else:
				f.save(filepath)
				output = subprocess.check_output(
					["/bin/file",'-b', filepath], 
					shell=False, 
					encoding='utf-8',
					timeout=1
				)
				
				if "ASCII text" not in output:
					output=f"<p style='color:red'>Error: The file is not a text file: {output}</p>"
				else:
					output="Wishlist received. Santa will check out soon!"

				os.remove(filepath)
				return render_template_string(output)

	except:
		return render_template_string("Error")

if __name__ == '__main__':
	serve(app, host="0.0.0.0", port=3000, threads=1000, cleanup_interval=30)