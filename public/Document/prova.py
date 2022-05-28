from docx2pdf import convert
import sys

# el = str(sys.argv)
convert("./Document/" + sys.argv[1] + ".docx")



# convert("input.docx", "output.pdf")
# convert("./")